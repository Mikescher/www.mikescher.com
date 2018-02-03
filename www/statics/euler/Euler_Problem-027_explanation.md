If you looked at the previous problems you probably know what comes now ... (Sieve of Eratosthenes)[https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes].  
To lower the amount of A-B combinations we have to check here are 2 rules I found out:

- `B` must be a (positive) prime, otherwise n=0 wouldn't yield a prime number
- When `B` is a prime `A` must be uneven. Otherwise for n=0 the resulting number would be even and so not a prime.