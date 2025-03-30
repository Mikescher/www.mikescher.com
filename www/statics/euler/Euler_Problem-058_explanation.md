It's obvious that the bottleneck of this program is the primality test.
The numbers become here too big to create a sieve and "normal" prime testing takes too long.
So we use the [Miller-Rabin primality test](https://en.wikipedia.org/wiki/Miller-Rabin_primality_test) that I implemented a while ago (thanks [mathblog.dk](https://web.archive.org/web/20150314052138/http://www.mathblog.dk/project-euler-58-primes-diagonals-spiral/)).  
The rest is just enumerating all the diagonals until `primes*10<all`