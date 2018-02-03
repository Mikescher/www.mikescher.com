It's obvious that the bottleneck of this program is the primality test.
The numbers become here too big to create a sieve and "normal" prime testing takes too long.
So we use the [Miller-Rabin primality test](https://en.wikipedia.org/wiki/Miller-Rabin_primality_test) that I implemented a while ago (thank [mathblog.dk](http://www.mathblog.dk)).  
The rest is just enumerating all the diagonals until `primes*10<all`