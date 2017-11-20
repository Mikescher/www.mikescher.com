This is a relative straightforward problem:

 - First we calculate all primes from `0` to `200 000` with a sieve of Eratosthenes.
 - Then we collect all primes side by side together in the top rows, because we only need to iterate through the primes and never actually do a prime test.
 - If we iterate through all the primes and test the divisibility we can calculate the number of *distinct prime*
 - So we check every fourth number (if it has 4 distinct prime factors).
 - If we found one, we test the 7 surrounding numbers for 4 adjacent matches (the first one we print out and exit the program)

This program is not that fast, even I did multiple performance improvements:

 - We pre-calculate the primes with an sieve of Eratosthenes
 - We generate an easily iterable array of primes
 - We test only every 4th number - this reduces the number of distinct prime factor calculations greatly
 - We early exit the "test 7 surrounding numbers" method, when we reached a point where there can't be a positive result

But still, it's mostly optimised brute force and not pretty fast.