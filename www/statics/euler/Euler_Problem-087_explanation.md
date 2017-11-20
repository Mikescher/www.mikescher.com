Here we iterate quite simply through all the `primes[a]^2 + primes[b]^3 + primes[c]^4` combinations and remember the already found ones.

The prime numbers are generated with the help from our old friend the [Sieve of Eratosthenes](https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes)
*(i improved my befunge snippet for this algorithm a little bit. It's now a bit faster and smaller in size)*.

The main problem was that we needed an bit-array with an size of **fifty million bits**.
Normally I would simply use an array of size fifty million. But we need to only store Boolean information.
So I used a "trick" were I stored sixty bits per cell (these are 64-bit values, but I wanted to prevent signed/unsigned problems and I had the problem that the stack is also only 64-bit).
Unfortunately befunge has no bit operators. So we had to re-invent bit-setting and bit-getting with division, modulo and addition operators.

In the end this didn't make the program fast, but the file size is under 1MB. And I think the run time is acceptable.