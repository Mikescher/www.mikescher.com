The trick is to use a sieve to pre-calculate all the proper-divisor-sums.
We use a big 1000x1000 array to store all the proper-divisor-sums of all numbers from one to one million.
Initially we set all these fields to zero, then we add `1` to all multiples of `1`, the `2` to all multiples to `2` etc, etc.
At the end we have a nice map of all the interesting numbers. (Fun fact: we have also calculated the primes, every number for which the sum is `1` is prime).

Then we use a second 1000x1000 array to remember the values we have already checked.
The rest is simply iterating through all the numbers, trying to build a chain for each one and remembering the length of the longest chain together with its smallest member.
While doing this we track the visited values in our cache array to prevent checking the same chain multiple times.

This code is not the fastest in befunge, but I honestly can't see a way to gain big performance (the same code in C# runs in 107ms).
Most of the time is spend with building the map of the amicable values, but all approaches with calculating them on-demand where way worse than this algorithm.