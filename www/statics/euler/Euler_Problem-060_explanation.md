Wow, so this is now officially my biggest (in terms of file size) befunge program.
The file has around ten megabyte. And probably also in terms of unique variables (26 variables plus two 2D-arrays)

The problem was also not that *befunge-compatible*.
My solution is pretty similar with the one from [MathBlog](http://www.mathblog.dk/project-euler-60-primes-concatenate/).
We generate primes from `1` to `3300` and save verified pairs in an Hashmap.
And when I say Hashmap I mean an *fucking* `3000x3000` array where every possible pair has an field (yay for befunge).

I had to use quite a few codesnippets from older project:
My standard [sieve of eratosthenes](http://en.wikipedia.org/wiki/Sieve_of_Eratosthenes), an implementation of the [Miller-Rabin primality test](http://en.wikipedia.org/wiki/Miller%E2%80%93Rabin_primality_test) and method to [concatenate two numbers](http://www.mathblog.dk/files/euler/Problem60.cs).

In the end is to say that in befunge the program size is normally an good indicator for the runtime (not really, but its kinda correct for all my programs).
So as you probably guessed this program takes a pretty loooooong time to complete.
I even had to make some aspects dynamic so I could test it with only 4 concatenated primes (and an sieve of size 9000).
Otherwise it would be impossible to debug it (or at least very tiresome).