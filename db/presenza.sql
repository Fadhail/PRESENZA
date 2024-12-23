-- Membuat Database
CREATE DATABASE presenza;

-- Menggunakan Database
USE presenza;

-- Membuat Tabel User
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'mahasiswa') NOT NULL DEFAULT 'mahasiswa',
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat Tabel Kelas
CREATE TABLE kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_kelas VARCHAR(20) NOT NULL UNIQUE,
    nama_kelas VARCHAR(100) NOT NULL
);

-- Membuat Tabel Mahasiswa
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    npm VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    kelas_id INT NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    descriptror TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);

-- Membuat Tabel Status
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_status VARCHAR(50) NOT NULL UNIQUE
);

-- Membuat Tabel Rekapitulasi
CREATE TABLE rekapitulasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    tanggal DATE NOT NULL,
    status_id INT NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES status(id) ON DELETE CASCADE
);

-- Menambahkan Data Awal untuk Tabel Status
INSERT INTO status (nama_status) VALUES
('hadir'),
('izin'),
('sakit'),
('alfa');

-- Menambahkan Data Awal untuk Tabel Kelas
INSERT INTO kelas (kode_kelas, nama_kelas) VALUES
('TI2024', 'Teknik Informatika 2024'),
('SI2024', 'Sistem Informasi 2024');

-- Menambahkan Index untuk Optimasi
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_mahasiswa_npm ON mahasiswa(npm);
CREATE INDEX idx_rekapitulasi_tanggal ON rekapitulasi(tanggal);