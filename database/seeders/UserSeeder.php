<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Staff Members
        $this->createUser('John', 'A.', 'Smith', '1980-05-12', 'john.smith@example.com', 'American', 'male', '123 Main St, NY', '123-456-7890', 'P123456789', 1, 'activated');
        $this->createUser('Emma', 'B.', 'Johnson', '1985-08-22', 'emma.johnson@example.com', 'British', 'female', '456 Elm St, London', '987-654-3210', 'GB987654321', 1, 'activated');

        // Tutors
        $this->createUser('David', 'C.', 'Brown', '1978-03-15', 'david.brown@example.com', 'Canadian', 'male', '789 Oak St, Toronto', '555-123-6789', 'CA555123456', 2, 'activated');
        $this->createUser('Sophia', 'D.', 'Miller', '1982-11-10', 'sophia.miller@example.com', 'Australian', 'female', '101 Pine St, Sydney', '444-567-8901', 'AU444567890', 2, 'activated');
        $this->createUser('James', 'E.', 'Wilson', '1990-07-05', 'james.wilson@example.com', 'American', 'male', '202 Cedar St, LA', '222-999-8888', 'P222999888', 2, 'activated');
        $this->createUser('Isabella', 'F.', 'Moore', '1983-12-20', 'isabella.moore@example.com', 'Canadian', 'female', '303 Birch St, Vancouver', '777-888-9999', 'CA777888999', 2, 'activated');

        // Students (showing first few, apply similar pattern to others)
        $this->createUser('Liam', null, 'Anderson', '2002-01-15', 'liam.anderson@example.com', 'American', 'male', '456 Maple St, NY', '333-222-1111', 'P333222111', 3, 'activated');
        $this->createUser('Olivia', null, 'Thomas', '2001-05-30', 'olivia.thomas@example.com', 'British', 'female', '789 Willow St, London', '555-666-7777', 'GB555666777', 3, 'activated');
        // Students
        $this->createUser('Noah', null, 'Martinez', '2003-09-25', 'noah.martinez@example.com', 'Mexican', 'male', '123 Elm St, Mexico City', '111-333-5555', 'MX111333555', 3, 'activated');
        $this->createUser('Emma', null, 'Harris', '2002-04-10', 'emma.harris@example.com', 'Australian', 'female', '654 Oak St, Melbourne', '444-555-6666', 'AU444555666', 3, 'activated');
        $this->createUser('William', null, 'Clark', '2001-07-18', 'william.clark@example.com', 'Canadian', 'male', '345 Birch St, Toronto', '777-888-9999', 'CA777888999', 3, 'activated');
        $this->createUser('Ava', null, 'Lewis', '2003-02-27', 'ava.lewis@example.com', 'British', 'female', '222 Cedar St, London', '888-999-0000', 'GB888999000', 3, 'activated');
        $this->createUser('James', null, 'Young', '2002-06-12', 'james.young@example.com', 'American', 'male', '111 Oak St, NY', '999-888-7777', 'P999888777', 3, 'activated');
        $this->createUser('Sophia', null, 'King', '2001-10-05', 'sophia.king@example.com', 'Canadian', 'female', '666 Pine St, Vancouver', '666-555-4444', 'CA666555444', 3, 'activated');
        $this->createUser('Benjamin', null, 'Walker', '2002-03-20', 'benjamin.walker@example.com', 'Australian', 'male', '555 Willow St, Sydney', '111-222-3333', 'AU111222333', 3, 'activated');
        $this->createUser('Mia', null, 'Hall', '2003-08-14', 'mia.hall@example.com', 'British', 'female', '444 Maple St, London', '444-333-2222', 'GB444333222', 3, 'activated');
        $this->createUser('Lucas', null, 'Allen', '2001-11-11', 'lucas.allen@example.com', 'American', 'male', '333 Elm St, LA', '777-666-5555', 'P777666555', 3, 'activated');
        $this->createUser('Charlotte', null, 'Perez', '2002-12-22', 'charlotte.perez@example.com', 'Mexican', 'female', '999 Birch St, Mexico City', '333-444-5555', 'MX333444555', 3, 'activated');
        $this->createUser('Henry', null, 'Robinson', '2001-09-09', 'henry.robinson@example.com', 'Canadian', 'male', '888 Cedar St, Toronto', '666-777-8888', 'CA666777888', 3, 'activated');
        $this->createUser('Amelia', null, 'Garcia', '2003-05-01', 'amelia.garcia@example.com', 'Spanish', 'female', '777 Pine St, Madrid', '555-666-7777', 'ES555666777', 3, 'activated');
        $this->createUser('Elijah', null, 'Rodriguez', '2002-07-17', 'elijah.rodriguez@example.com', 'American', 'male', '222 Willow St, NY', '111-999-0000', 'P111999000', 3, 'activated');
        $this->createUser('Isabella', null, 'Lopez', '2001-08-08', 'isabella.lopez@example.com', 'Mexican', 'female', '111 Maple St, Mexico City', '333-222-1111', 'MX333222111', 3, 'activated');
        $this->createUser('Alexander', null, 'Scott', '2003-01-19', 'alexander.scott@example.com', 'Canadian', 'male', '444 Oak St, Toronto', '555-444-3333', 'CA555444333', 3, 'activated');
        $this->createUser('Harper', null, 'Adams', '2002-11-23', 'harper.adams@example.com', 'British', 'female', '666 Cedar St, London', '999-888-7777', 'GB999888777', 3, 'activated');
        $this->createUser('Daniel', null, 'Baker', '2001-12-12', 'daniel.baker@example.com', 'Australian', 'male', '555 Birch St, Sydney', '777-666-5555', 'AU777666555', 3, 'activated');
        $this->createUser('Evelyn', null, 'Gonzalez', '2002-06-06', 'evelyn.gonzalez@example.com', 'Mexican', 'female', '999 Elm St, Mexico City', '111-222-3333', 'MX111222333', 3, 'activated');
        $this->createUser('Matthew', null, 'Nelson', '2001-02-20', 'matthew.nelson@example.com', 'American', 'male', '888 Maple St, LA', '444-333-2222', 'P444333222', 3, 'activated');
        $this->createUser('Abigail', null, 'Carter', '2003-09-30', 'abigail.carter@example.com', 'Canadian', 'female', '777 Cedar St, Toronto', '555-666-7777', 'CA555666777', 3, 'activated');
    }

    /**
     * Create a user with the given attributes
     */
    private function createUser($firstName, $middleName, $lastName, $dob, $email, $nationality, $gender, $address, $phone, $passport, $roleId, $status)
    {
        DB::table('users')->insert([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'date_of_birth' => Carbon::parse($dob),
            'email' => $email,
            'password' => Hash::make('password'),
            'nationality' => $nationality,
            'gender' => $gender,
            'address' => $address,
            'phone_number' => $phone,
            'passport' => $passport,
            'profile_picture' => null,
            'role_id' => $roleId,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}