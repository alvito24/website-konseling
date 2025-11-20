# TODO: Overhaul to "Aplikasi Hati dan Layar Bersatu"

## Overview
Transform the Laravel application into a comprehensive counseling system with new models, roles, and features as specified.

## Current State
- Some migrations created (with duplicates)
- Basic models created
- Controllers created
- User model updated with relationships

## New Plan

### 1. Database Schema Updates
- [ ] Remove duplicate migration files (e.g., multiple gurus, jadwals, materi tables)
- [ ] Update migrations with new fields:
  - Guru: photo, NIK/NIP unique, password, jabatan (BK/Wali)
  - Siswa: photo, NIS unique, gender, jurusan, rencana_karir, password
  - Jadwal: guru_id (only BK), hari, sesi (1-6), ruang (BK-101-103), status
  - Booking: siswa_id, jadwal_id, kategori_masalah, status_masalah, status
  - Jurnal: no_jurnal auto, jenis (Private/Public), siswa_id, rekomendasi_guru (nullable)
  - Materi: judul, file_path, uploaded_by, public (boolean), views
  - Diskusi: judul, content, created_by, active (boolean)
  - ForumComment: diskusi_id, user_id, content, likes
- [ ] Add new migrations for reviews, etc. if needed
- [ ] Run migrations

### 2. Model Updates
- [ ] Update Guru model: add fillable, relationships to jadwals, user
- [ ] Update Siswa model: add fillable, relationships to bookings, jurnals, user
- [ ] Update Jadwal model: add fillable, relationships to guru, bookings
- [ ] Update Booking model: add fillable, relationships to siswa, jadwal
- [ ] Update Jurnal model: add fillable, relationships to siswa, user (for review)
- [ ] Update Materi model: add fillable, relationships to uploader
- [ ] Update Diskusi model: add fillable, relationships to creator, comments
- [ ] Update ForumComment model: add fillable, relationships to diskusi, user
- [ ] Update User model: add role relationships, profile fields

### 3. Controllers
- [ ] Update SiswaController: CRUD with photo upload, validation
- [ ] Update JadwalController: CRUD with validation for BK only, conflict check
- [ ] Update MateriController: CRUD with file upload, progress bar
- [ ] Create BookingController: CRUD, auto-disable jadwal after booking
- [ ] Create JurnalController: CRUD for siswa, review for guru BK
- [ ] Create DiskusiController: CRUD for admin/guru
- [ ] Create ForumController: comments, likes
- [ ] Update AdminController: manage all
- [ ] Create PublicController: landing page, public browser

### 4. Routes
- [ ] Update web.php: public routes for landing, auth routes with middleware
- [ ] Add role-based route groups: admin, guru_bk, guru_wali, siswa
- [ ] Public routes: landing, materi browser, jadwal view, diskusi view

### 5. Views and UI
- [ ] Create landing page: jadwal publik, materi publik, info BK, tombol masuk
- [ ] Update layouts: sidebar navigation, modern responsive, blue/white theme
- [ ] Create dashboards: role-specific with sidebar
- [ ] Create forms: guru (with photo), siswa (with photo), jadwal (dropdowns), booking, jurnal, materi (upload), diskusi
- [ ] Create browsers: materi (search, popular), jadwal, diskusi
- [ ] Update auth views: remove as home, redirect to landing

### 6. Features Implementation
- [ ] Booking system: select jadwal, auto-disable, kategori/status
- [ ] Jurnal system: auto no, private/public, review by guru BK
- [ ] Materi bank: upload with progress, viewer, public access
- [ ] Diskusi/Forum: create, comment, like, hide inactive
- [ ] Validations: unique NIK/NIS, conflict jadwal, file types
- [ ] Public access: no login for landing and some views

### 7. Testing and Finalization
- [ ] Test all CRUD operations
- [ ] Test role access
- [ ] Test public sections
- [ ] Update seeders if needed
- [ ] Clean up old files/views not used

## Dependent Files
- All migrations, models, controllers, views, routes
- Config files for roles, file uploads

## Followup Steps
- Deploy and test in production
- Add notifications for bookings, reviews
- Optimize performance for file uploads
