This is effectively an optimized implementation of [this algorithm](http://www.mathblog.dk/project-euler-51-eight-prime-family/).  
You can see the ten patterns on the left side and beside them the area were we build our numbers.

So what we do is iterate through the numbers from `100` to `1 000`, through the ten patterns and through the digits `0`, `1` and `2`.
In each iteration we generate the number (from value, pattern and digit) and test for it primeness (with a simple [primality test](https://en.wikipedia.org/wiki/Primality_test) - no prime sieve).
If we found a prime we count the number of primes in it's family and if this count is eight we print the generated number and exit.

This program is not the fastest, because I check all the primes "manually" and not with an prime sieve each iteration takes quite a time.
But I wanted this to fit into the befunge-93 size restrictions, and even without a sieve the execution time is OK - for a befunge program.