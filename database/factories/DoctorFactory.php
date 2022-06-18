<?php
namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

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

        $statuses = [
            'Active',
            'InActive'
        ];
        shuffle($statuses);

        return [
            'name' => $this->faker->name,
            'age' => rand(20, 60),
            'gender' => $genders[0],
            'contact_no' => $this->faker->phoneNumber,
            'email_address' => $this->faker->email,
            'address' => $this->faker->address,
            'specialization' => '',
            'qualification' => '',
            'status' => $statuses[0]
        ];
    }
}
