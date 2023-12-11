<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createComment = new Permission();
        $createComment->name = 'Create comments';
        $createComment->slug = 'create comments';
        $createComment->save();

        $deleteComment = new Permission();
        $deleteComment->name = 'Delete comments';
        $deleteComment->slug = 'delete comments';
        $deleteComment->save();

        $editComment = new Permission();
        $editComment->name = 'Edit comments';
        $editComment->slug = 'edit comments';
        $editComment->save();

        $createArticle = new Permission();
        $createArticle->name = 'Create article';
        $createArticle->slug = 'create article';
        $createArticle->save();

        $editArticle = new Permission();
        $editArticle->name = 'Edit article';
        $editArticle->slug = 'edit article';
        $editArticle->save();

        $deleteArticle = new Permission();
        $deleteArticle->name = 'Delete article';
        $deleteArticle->slug = 'delete article';
        $deleteArticle->save();
    }
}
