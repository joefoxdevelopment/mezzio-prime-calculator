# Mezzio prime number calculator

This is a single endpoint api, to determine whether a query param `number` is a prime number.

To test if number is a prime, ALL of the following must be true of the number being tested
- the value of `number` is an integer
- the value of `number` is greater than or equal to 2
- the value of `number` is less than or equal to 10,000,000

## How to get up and running locally
This assumes you've got a shell open and in the root of the repo, and the php version is 7.2 or greater
```lang=bash
./composer.phar install
./composer.phar serve
```

There's also a few composer scripts added to make the code quality checks easier to run repeatedly. Have a look in the
composer.json for these

## Examples
### Testing a prime number
```bash
curl http://localhost:8080\?number\=23 | jq .
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100   101    0   101    0     0  33666      0 --:--:-- --:--:-- --:--:-- 33666
{
  "number": 23,
  "isPrime": true,
  "calculationMethod": "Calculated",
  "calculationTime": 3.0994415283203125e-06
}
```

### Testing a non-prime number
```bash
curl http://localhost:8080\?number\=24 | jq .
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100    99    0    99    0     0  33000      0 --:--:-- --:--:-- --:--:-- 33000
{
  "number": 24,
  "isPrime": false,
  "calculationMethod": "Calculated",
  "calculationTime": 9.5367431640625e-07
}
```

### Testing a stored prime number
```bash
curl http://localhost:8080\?number\=5 | jq .
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100    82    0    82    0     0  11714      0 --:--:-- --:--:-- --:--:-- 11714
{
  "number": 5,
  "isPrime": true,
  "calculationMethod": "Datastore",
  "calculationTime": null
}
```

### Testing a stored non-prime number
```bash
curl http://localhost:8080\?number\=15 | jq .
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100    84    0    84    0     0  10500      0 --:--:-- --:--:-- --:--:-- 10500
{
  "number": 15,
  "isPrime": false,
  "calculationMethod": "Datastore",
  "calculationTime": null
}
```
