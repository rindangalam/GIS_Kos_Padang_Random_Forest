"""
Flask backend untuk web kos-kosan:
- Endpoint /api/kost: Mengambil data kost dengan paginasi.
- Endpoint /api/pencarian: Mengambil data kost dengan filter pencarian (keyword, kecamatan, kampus, kategori, tipe_kamar, harga_min, harga_max, fasilitas, paginasi).
- Koneksi ke database MySQL.
- Mendukung CORS agar bisa diakses dari frontend PHP.

Author: [Rindang Alam Nur Muhammad]
Tanggal: 2025-06-25
"""
from flask import Flask, jsonify, request
from flask_mysqldb import MySQL
from flask_cors import CORS
import joblib

app = Flask(__name__)
CORS(app)

# Konfigurasi database
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'ajokosssss'

mysql = MySQL(app)

# Load model Random Forest
rf_model = joblib.load('model_rf.pkl')

@app.route('/api/kost', methods=['GET'])
def get_kost():
    start = request.args.get('start', default=0, type=int)
    limit = request.args.get('limit', default=20, type=int)
    cur = mysql.connection.cursor()
    query = "SELECT kost.*, user.foto_profil, user.nama_lengkap FROM kost JOIN user ON kost.id_pemilik=user.id ORDER BY kost.id_kost ASC LIMIT %s, %s"
    cur.execute(query, (start, limit))
    rows = cur.fetchall()
    columns = [desc[0] for desc in cur.description]
    data = [dict(zip(columns, row)) for row in rows]
    cur.close()
    return jsonify(data)

@app.route('/api/pencarian', methods=['GET'])
def api_pencarian():



    # Ambil parameter dari user (semua, tapi filter di Python)
    params = request.args
    keyword = params.get('keyword', '').strip()
    filter_kecamatan = params.get('kecamatan', '').strip()
    filter_kampus = params.get('kampus', '').strip()
    filter_jenis_kost = params.get('kategori', '').strip()
    filter_tipe_kost = params.get('tipe_kost', '').strip()
    harga_min = int(params.get('harga_min', 0) or 0)
    harga_max = int(params.get('harga_max', 99999999) or 99999999)
    filter_fasilitas = params.getlist('fasilitas') if 'fasilitas' in params else []
    start = int(params.get('start', 0) or 0)
    limit = int(params.get('limit', 20) or 20)

    # Ambil semua data kost (atau bisa dibatasi jumlah besar jika data sangat banyak)
    cur = mysql.connection.cursor()
    query = "SELECT id_kost, nama_kost, deskripsi, kecamatan, kampus, jenis_kost, tipe_kost, harga_sewa, fasilitas_kost FROM kost"
    cur.execute(query)
    rows = cur.fetchall()
    columns = [desc[0] for desc in cur.description]

    # Mapping untuk fitur numerik
    kecamatan_map = {'Kuranji': 1, 'Padang Utara': 2, 'Lubuk Begalung': 3, 'Koto Tangah': 4, 'Padang Barat': 5, 'Padang Selatan': 6, 'Padang Timur': 7, 'Nanggalo': 8, 'Pauh': 9}
    kampus_map = {'kampus 2 UIN Imam Bonjol Padang': 1, 'UIN Imam Bonjol Padang': 2, 'UIN Imam Bonjol Padang Kampus 3': 3, 'UPI YPTK Padang': 4, 'Universitas Adzkia': 5, 'Universitas Andalas': 6, 'Universitas Bung Hatta': 7, 'Universitas Dharma Andalas': 8, 'Universitas Negeri Padang': 9, 'Universitas Putra Indonesia YPTK': 10}
    jenis_kost_map = {'Putra': 0, 'Putri': 1}
    tipe_kost_map = {'Tahun': 0, 'Bulan': 1}
    fasilitas_master = ['WIFI/Internet', 'Dapur', 'Parkir Mobil', 'Laundry', 'Security', 'Musholla', 'Ruang Tamu']

    id_kost_lolos = []
    for row in rows:
        data = dict(zip(columns, row))
        # Filter di Python (bukan SQL)
        if filter_kecamatan and str(data['kecamatan']).strip() != filter_kecamatan:
            continue
        if filter_kampus and str(data['kampus']).strip() != filter_kampus:
            continue
        if filter_jenis_kost and str(data['jenis_kost']).strip() != filter_jenis_kost:
            continue
        if filter_tipe_kost and str(data['tipe_kost']).strip() != filter_tipe_kost:
            continue
        if data['harga_sewa'] < harga_min or data['harga_sewa'] > harga_max:
            continue
        if keyword and (keyword.lower() not in str(data['nama_kost']).lower() and keyword.lower() not in str(data['deskripsi']).lower()):
            continue
        if filter_fasilitas:
            fasilitas_kost = str(data['fasilitas_kost'])
            if not all(f.lower() in fasilitas_kost.lower() for f in filter_fasilitas):
                continue
        fitur = [
            kecamatan_map.get(str(data['kecamatan']).strip().title(), 0),
            kampus_map.get(str(data['kampus']).strip(), 0),
            jenis_kost_map.get(str(data['jenis_kost']).strip(), 0),
            tipe_kost_map.get(str(data['tipe_kost']).strip(), 0),
            data['harga_sewa']
        ]
        for fas in fasilitas_master:
            fitur.append(1 if fas in str(data['fasilitas_kost']) else 0)
        prediksi = rf_model.predict([fitur])[0]
        # Tambahkan semua data hasil prediksi (murah, sedang, mahal)
        if prediksi in [1, 2, 3]:
            id_kost_lolos.append(data['id_kost'])
    cur.close()

    # Jika tidak ada yang lolos, return kosong
    if not id_kost_lolos:
        return jsonify({"status": True, "jumlah": 0, "data": []})

    # Ambil data lengkap dari MySQL berdasarkan id_kost hasil klasifikasi, join ke user
    cur = mysql.connection.cursor()
    format_strings = ','.join(['%s'] * len(id_kost_lolos))
    query_detail = f"SELECT kost.*, user.foto_profil, user.nama_lengkap FROM kost JOIN user ON kost.id_pemilik=user.id WHERE kost.id_kost IN ({format_strings}) ORDER BY kost.id_kost ASC"
    cur.execute(query_detail, tuple(id_kost_lolos))
    rows_detail = cur.fetchall()
    columns_detail = [desc[0] for desc in cur.description]
    data_detail = [dict(zip(columns_detail, row)) for row in rows_detail]
    cur.close()

    # Pagination manual
    data_paginated = data_detail[start:start+limit]
    return jsonify({"status": True, "jumlah": len(data_detail), "data": data_paginated})

@app.route('/')
def index():
    return "Flask backend is running with Random Forest filtering on pencarian and /api/kost restored."

if __name__ == '__main__':
    app.run(debug=True)
