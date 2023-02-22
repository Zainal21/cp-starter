<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // posts
            ['name' => 'post-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Postingan'],
            ['name' => 'post-create', 'guard_name' => 'web', 'general_name' => 'Membuat Postingan'],
            ['name' => 'post-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Postingan'],
            ['name' => 'post-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Postingan'],
            ['name' => 'publish-post', 'guard_name' => 'web', 'general_name' => 'Mempublish Postingan'],
            ['name' => 'archive-post', 'guard_name' => 'web', 'general_name' => 'Mengarsipkan Postingan'],
            ['name' => 'trash-post', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Postingan yang Dihapus'],
            // category
            ['name' => 'category-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Kategori'],
            ['name' => 'category-create', 'guard_name' => 'web', 'general_name' => 'Membuat Kategori'],
            ['name' => 'category-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Kategori'],
            ['name' => 'category-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Kategori'],
            // roles
            ['name' => 'roles-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Hak Akses Pengguna'],
            ['name' => 'roles-create', 'guard_name' => 'web', 'general_name' => 'Membuat Hak Akses Pengguna'],
            ['name' => 'roles-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Hak Akses Pengguna'],
            ['name' => 'roles-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Hak Akses Pengguna'],
            //  users
            ['name' => 'users-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Pengguna'],
            ['name' => 'users-create', 'guard_name' => 'web', 'general_name' => 'Membuat Pengguna Baru'],
            ['name' => 'users-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Role Pengguna'],
            ['name' => 'users-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Pengguna'],
            // site setting
            ['name' => 'site-setting-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Informasi Website'],
            // sliders
            ['name' => 'sliders-list', 'guard_name' => 'web', 'general_name' => 'Melihat List Slider'],
            ['name' => 'sliders-create', 'guard_name' => 'web', 'general_name' => 'Membuat Slider Baru'],
            ['name' => 'sliders-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Data Slider'],
            ['name' => 'sliders-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Data Slider'],
            // backup
            ['name' => 'backup-apps-and-db', 'guard_name' => 'web', 'general_name' => 'Mencadangkan App & DB'],
        ];

        Permission::insert($permissions);
    }
}
