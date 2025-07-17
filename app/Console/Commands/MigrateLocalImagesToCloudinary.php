<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class MigrateLocalImagesToCloudinary extends Command
{
    protected $signature = 'migrate:local-images-to-cloudinary';
    protected $description = 'ローカル画像をCloudinaryに一括移行し、DBのimageカラムをURLに更新する';

    public function handle()
    {
        $users = User::where('image', 'not like', 'http%')->whereNotNull('image')->get();

        foreach ($users as $user) {
            $localPath = storage_path('app/public/' . ltrim($user->image, '/'));
            if (file_exists($localPath)) {
                $this->info("Uploading: {$localPath}");
                $uploadedUrl = Cloudinary::upload($localPath)->getSecurePath();
                $user->image = $uploadedUrl;
                $user->save();
                $this->info("Updated user {$user->id} image to Cloudinary URL");
            } else {
                $this->error("File not found: {$localPath}");
            }
        }

        $this->info('全ユーザーのローカル画像をCloudinaryに移行しました。');
    }
}
