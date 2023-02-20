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
            // ['name' => 'category-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Kategori'],
            // ['name' => 'category-create', 'guard_name' => 'web', 'general_name' => 'Membuat Kategori'],
            // ['name' => 'category-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Kategori'],
            // ['name' => 'category-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Kategori'],
            //  users
            // ['name' => 'category-list', 'guard_name' => 'web', 'general_name' => 'Melihat Daftar Kategori'],
            // ['name' => 'category-create', 'guard_name' => 'web', 'general_name' => 'Membuat Kategori'],
            // ['name' => 'category-edit', 'guard_name' => 'web', 'general_name' => 'Mengubah Kategori'],
            // ['name' => 'category-delete', 'guard_name' => 'web', 'general_name' => 'Menghapus Kategori'],
        ];

        Permission::insert($permissions);
    }
}
