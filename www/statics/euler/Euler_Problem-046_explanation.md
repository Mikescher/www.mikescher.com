I really missed my [sieve of erastothenes](https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes). There were really a few problems without primes in a row.

In this problem we go through all primes `i`, search through all smaller primes `j` were `(i-j)/2` is a quadratic number. If you can't find one, this falsifies the theorem.

Also we use the code from problem 46 to calculate the integer square root.