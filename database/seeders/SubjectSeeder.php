<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Computer Science
            'Data Structures and Algorithms',
            'Database Management Systems',
            'Operating Systems',
            'Computer Networks',
            'Artificial Intelligence',
            'Machine Learning',
            'Cybersecurity',

            // Information Technology
            'IT Project Management',
            'Cloud Computing',
            'Network Security',
            'Web Development',
            'System Analysis and Design',

            // Software Engineering
            'Software Development Methodologies',
            'Agile Software Engineering',
            'DevOps',
            'Mobile App Development',
            'Software Testing and Quality Assurance',

            // Data Science
            'Big Data Analytics',
            'Data Visualization',
            'Python for Data Science',
            'Statistics for Data Science',
            'Deep Learning',

            // Cybersecurity
            'Ethical Hacking',
            'Network Security',
            'Cryptography',
            'Cyber Law and Ethics',
            'Incident Response and Forensics',

            // Business Administration
            'Organizational Behavior',
            'Business Analytics',
            'Financial Management',
            'Human Resource Management',
            'Marketing Principles',

            // Accounting and Finance
            'Financial Accounting',
            'Managerial Accounting',
            'Investment Analysis',
            'Taxation',
            'Auditing',

            // Marketing
            'Consumer Behavior',
            'Digital Marketing',
            'Marketing Research',
            'Sales Management',
            'Brand Management',

            // Engineering (Mechanical, Electrical, Civil, Biomedical)
            'Engineering Mathematics',
            'Thermodynamics',
            'Electrical Circuits',
            'Structural Analysis',
            'Biomedical Instrumentation',

            // Graphic Design & Multimedia Arts
            'Typography and Layout',
            '3D Modeling and Animation',
            'Visual Communication',
            'Video Editing',
            'User Experience (UX) Design',

            // Psychology
            'Cognitive Psychology',
            'Behavioral Neuroscience',
            'Clinical Psychology',
            'Social Psychology',

            // Law
            'Constitutional Law',
            'Criminal Law',
            'International Law',
            'Corporate Law',

            // Education
            'Curriculum Development',
            'Educational Psychology',
            'Classroom Management',

            // Environmental Science
            'Ecology',
            'Environmental Policy',
            'Climate Change',
            'Sustainability Studies',
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'name' => $subject,
            ]);
        }
    }
}