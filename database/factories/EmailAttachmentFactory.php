<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class EmailAttachmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailAttachment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileName = $this->faker->word.'.'.$this->faker->fileExtension;

        return [
            'email_id' => Email::factory(),
            'file_name' => $fileName,
            'file_path' => '/'.$this->faker->word.'/'.$this->faker->word.'/'.$fileName
        ];
    }
}
