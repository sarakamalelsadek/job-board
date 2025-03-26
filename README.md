# Job Board

## Introduction
This is a Laravel-based job board API project that allows users to filter job listings based on various attributes such as location, category, and salary range.

## Requirements
- **PHP** 8+
- **Laravel** 10+
- **MySQL**
- **Composer**

## Installation

```bash
# Clone the repository
git clone https://github.com/sarakamalelsadek/job-board.git

# Navigate to the project directory
cd job-board

# Install dependencies
composer install

# Copy the environment file
cp .env.example .env

# Set up the database (update .env file with your DB credentials)
php artisan migrate --seed

# Start the development server
php artisan serve
```

# Job Filtering API
## Example Queries
1. **Basic Filtering**
    /api/jobs?filter={"title":"developer","job_type":"full-time"}
   
2. **AND Filtering**
   /api/jobs?filter={"title":"developer","salary_min":5000}

3. **OR Filtering**
    /api/jobs?filter={"OR":[{"title":"developer"},{"job_type":"full-time"}]}




## Thank You
