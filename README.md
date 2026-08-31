# GIS Kos Padang - Random Forest Classification

> **Geographic Information System for boarding house (kos-kosan) search in Padang City with Random Forest machine learning classification**

[![PHP](https://img.shields.io/badge/PHP-Native-777bb4)](https://www.php.net/)
[![Python](https://img.shields.io/badge/Python-3.x-3776ab)](https://www.python.org/)
[![Flask](https://img.shields.io/badge/Flask-Backend-000000)](https://flask.palletsprojects.com/)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479a1)](https://www.mysql.com/)
[![Scikit-learn](https://img.shields.io/badge/Scikit--learn-ML-f7931e)](https://scikit-learn.org/)

---

## 📋 Overview

**GIS Kos Padang** is a web-based geographic information system designed to help students and workers find suitable boarding houses (kos-kosan) in Padang City. The system uses **Random Forest classification algorithm** to intelligently filter and recommend boarding houses based on multiple criteria including location, price, facilities, and proximity to universities.

### Key Features
- **Smart search** with Random Forest ML classification (price category: cheap, moderate, expensive)
- **Interactive map** for geographic visualization of boarding house locations
- **Advanced filtering** by district, university campus, room type, price range, and facilities
- **User authentication** with role-based access (admin, owner, tenant)
- **Property management** for boarding house owners
- **Real-time availability** tracking

---

## ✨ Features

### For Tenants/Students
- Search boarding houses by keyword, location, campus proximity, and budget
- Filter by facilities (WiFi, kitchen, parking, laundry, security, prayer room, living room)
- View detailed property information with photos
- Interactive map with markers for each property
- Price classification using machine learning

### For Property Owners
- Register and manage boarding house listings
- Upload property photos and details
- Update room availability and pricing
- Manage facility information

### For Administrators
- User management (owners, tenants)
- Property approval and moderation
- System configuration

---

## 🛠️ Tech Stack

### Frontend
- **Native PHP** (no framework)
- **HTML5, CSS3, JavaScript**
- **Bootstrap** (responsive UI)
- **Leaflet.js** or Google Maps API (interactive maps)
- **jQuery** (AJAX requests)

### Backend
- **PHP** (main application logic)
- **Flask** (Python microservice for ML predictions)
- **MySQL** (database)

### Machine Learning
- **Python 3.x**
- **scikit-learn** (Random Forest classifier)
- **joblib** (model serialization)
- **Flask-MySQL** (database connector)

### APIs
- **Flask REST API** endpoints:
  - `/api/kost` - Get paginated boarding house data
  - `/api/pencarian` - Search with ML-based filtering

---

## 🚀 Getting Started

### Prerequisites
- **PHP 7.4+** with MySQL extension
- **Python 3.8+**
- **MySQL 5.7+** or MariaDB
- **pip** (Python package manager)
- **Web server** (Apache/Nginx) or PHP built-in server

### Installation

#### 1. Clone the repository
```bash
git clone https://github.com/rindangalam/GIS_Kos_Padang_Random_Forest.git
cd GIS_Kos_Padang_Random_Forest
```

#### 2. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE ajokosssss;
exit;

# Import database schema (if provided)
mysql -u root -p ajokosssss < database.sql
```

#### 3. Configure PHP Database Connection
Edit `php/koneksi.php` (or similar config file):
```php
$koneksi = mysqli_connect('localhost', 'root', '', 'ajokosssss');
```

#### 4. Install Python Dependencies
```bash
pip install flask flask-mysqldb flask-cors joblib scikit-learn
```

#### 5. Configure Flask Backend
Edit `app.py` database configuration:
```python
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'ajokosssss'
```

#### 6. Start Flask Backend
```bash
python app.py
```
Flask will run on `http://localhost:5000`

#### 7. Start PHP Development Server
```bash
php -S localhost:8000
```
Or configure Apache/Nginx to serve the project directory.

#### 8. Access the Application
```
http://localhost:8000
```

---

## 📁 Project Structure

```
GIS_Kos_Padang_Random_Forest/
├── css/                    # Stylesheets
├── js/                     # JavaScript files
├── img/                    # Images and assets
├── php/                    # PHP utility files (connection, helpers)
├── template/               # Header, footer, navigation templates
├── kost/                   # Boarding house photos/uploads
├── app.py                  # Flask backend with ML model
├── model_rf.pkl            # Trained Random Forest model
├── index.php               # Homepage
├── daftar.php              # Registration page
├── login.php               # Login page
├── tambah.php              # Add new property (owner)
├── tentang.php             # About page
└── README.md
```

---

## 🤖 Machine Learning Model

### Random Forest Classifier

The system uses a pre-trained Random Forest model (`model_rf.pkl`) to classify boarding houses into price categories:

**Features used:**
1. **District** (Kecamatan) - encoded: Kuranji, Padang Utara, Lubuk Begalung, etc.
2. **University Campus** (Kampus) - proximity to: UIN, Unand, UNP, UBH, etc.
3. **Gender Type** (Jenis Kost) - Male (Putra) or Female (Putri)
4. **Rental Period** (Tipe Kost) - Monthly (Bulan) or Yearly (Tahun)
5. **Price** (Harga Sewa)
6. **Facilities** (7 binary features): WiFi, Kitchen, Parking, Laundry, Security, Prayer Room, Living Room

**Classification Output:**
- Class 1: Cheap (Murah)
- Class 2: Moderate (Sedang)
- Class 3: Expensive (Mahal)

### How It Works
1. User submits search filters via web form
2. Frontend sends AJAX request to Flask `/api/pencarian` endpoint
3. Flask fetches all matching properties from MySQL
4. Each property is transformed into feature vector
5. Random Forest model predicts price category
6. Only properties matching the predicted category are returned
7. Results are paginated and displayed on the map

---

## 🗺️ Geographic Features

- Interactive map showing boarding house locations
- Marker clustering for better visualization
- District boundaries (Kecamatan)
- University campus markers
- Distance calculation from campus to property

---

## 🔐 User Roles

| Role | Capabilities |
|------|-------------|
| **Guest** | Browse listings, search, view map |
| **Tenant** | Same as guest + save favorites, contact owners |
| **Owner** | Manage properties, upload photos, update pricing |
| **Admin** | User management, property moderation, system config |

---

## 📊 Database Schema (Key Tables)

- `kost` - Boarding house properties (id_kost, nama_kost, deskripsi, kecamatan, kampus, harga_sewa, fasilitas_kost, etc.)
- `user` - Users (id, nama_lengkap, email, password, role, foto_profil)
- `kamar` - Rooms (id_kamar, id_kost, tipe_kamar, biaya_fasilitas, ketersediaan)

---

## 🎯 Use Cases

1. **Student** searching for affordable boarding house near Universitas Andalas with WiFi and parking
2. **Property owner** listing a new female-only boarding house in Kuranji district
3. **Admin** moderating new property submissions and managing user accounts
4. **Data analyst** training improved ML models with historical search and booking data

---

## 🔧 API Endpoints

### GET `/api/kost`
Get paginated boarding house data.

**Query Parameters:**
- `start` (int) - Offset for pagination (default: 0)
- `limit` (int) - Number of results (default: 20)

**Response:**
```json
[
  {
    "id_kost": 1,
    "nama_kost": "Kos Sejahtera",
    "kecamatan": "Kuranji",
    "kampus": "Universitas Andalas",
    "harga_sewa": 500000,
    "fasilitas_kost": "WIFI/Internet, Parkir Mobil",
    "foto_profil": "owner.jpg",
    "nama_lengkap": "John Doe"
  }
]
```

### GET `/api/pencarian`
Search with ML-based filtering.

**Query Parameters:**
- `keyword` (string) - Search term
- `kecamatan` (string) - District filter
- `kampus` (string) - Campus filter
- `kategori` (string) - Gender type (Putra/Putri)
- `tipe_kost` (string) - Rental period (Bulan/Tahun)
- `harga_min` (int) - Minimum price
- `harga_max` (int) - Maximum price
- `fasilitas` (array) - Facility filters
- `start`, `limit` - Pagination

**Response:**
```json
{
  "status": true,
  "jumlah": 15,
  "data": [...]
}
```

---

## 🧪 Development

### Training New ML Model
```python
# Use scikit-learn to train on your dataset
from sklearn.ensemble import RandomForestClassifier
import joblib

# Train model
rf_model = RandomForestClassifier(n_estimators=100)
rf_model.fit(X_train, y_train)

# Save model
joblib.dump(rf_model, 'model_rf.pkl')
```

### Testing Flask API
```bash
curl "http://localhost:5000/api/pencarian?kecamatan=Kuranji&harga_max=1000000"
```

---

## 🤝 Contributing

This project was developed as part of academic research. Contributions are welcome for:
- Improving ML model accuracy
- Adding new filtering features
- UI/UX enhancements
- Mobile responsive improvements

---

## 📄 License

This project is for educational and research purposes.

---

## 👤 Author

**Rindang Alam Nur Muhammad**  
GitHub: [@rindangalam](https://github.com/rindangalam)

---

## 🙏 Acknowledgments

- **scikit-learn** - Machine learning library
- **Flask** - Python microframework
- **Leaflet.js** - Interactive map library
- **Bootstrap** - UI framework
- Universities in Padang City for geographic data
