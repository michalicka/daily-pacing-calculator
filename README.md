# Daily Pacing Limit Calculator

## Installation

- clone repository to your file system
- copy `env.example` to `.env` and configure database access
- run `php artisan migrate:fresh --seed`

## Usage

`CalculateDailyPacing` job is scheduled to run daily in `Kernel::schedule`
but you can run this job manually by `php artisan pacing:calculate` 
with optional argument `date`

### Example

```sh
php artisan pacing:calculate 2021-05-25
```
