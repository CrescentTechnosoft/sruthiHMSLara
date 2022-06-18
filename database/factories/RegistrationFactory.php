<?php
namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $genders = [
            'Male',
            'Female'
        ];
        shuffle($genders);
        return [
            'salutation' => $genders[0] === 'Male' ? 'Mr' : 'Mrs',
            'name' => $this->faker->name,
            'age' => rand(25, 60),
            'gender' => $genders[0],
            'dob' => '',
            'contact_no' => $this->faker->phoneNumber,
            'email_address' => $this->faker->email,
            'address' => $this->faker->address,
            'consultant' => '',
            'user_id' => 1
        ];
    }
}
