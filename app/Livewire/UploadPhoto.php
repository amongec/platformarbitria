<?php
 
namespace App\Livewire;
 
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{
    use WithFileUploads;
 
    #[Validate('image|max:1024')]
    public $photo;
 
    // ...
}

    public function can_upload_photo()
    {
        Storage::fake('avatars');
 
        $file = UploadedFile::fake()->image('avatar.png');
 
        Livewire::test(UploadPhoto::class)
            ->set('photo', $file)
            ->call('upload', 'uploaded-avatar.png');
 
        Storage::disk('avatars')->assertExists('uploaded-avatar.png');
    }

        public function upload($name)
    {
        $this->photo->storeAs('/', $name, disk: 'avatars');
    }

 
/*class UploadPhoto extends Component
{
    use WithFileUploads;
 
    #[Validate('image|max:1024')] // 1MB Max
    public $photo;
 
    public function save()
    {
        $this->photo->store(path: 'photos');
    }
}*/
/*
class UploadPhotos extends Component
{
    use WithFileUploads;
 
    #[Validate(['photos.*' => 'image|max:1024'])]
    public $photos = [];
 
    public function save()
    {
        foreach ($this->photos as $photo) {
            $photo->store(path: 'photos');
        }
    }
}*/