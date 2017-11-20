For an extended explanation please look at problem-076, it's basically the same..

Yet again we remember already calculated values in an grid.
The only difference is now that our y-axis is the prime index (We generate a few primes with an [Sieve of Eratosthenes](https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes)).

And once we find a number which count is greater five thousand we abort and print this number.

The only mayor difference to problem-076 is that now not every summand is valid.
It is possible that you can use `prime[7]` but not `prime[6]`.
So we have to look at each possible summand individually.
This makes unfortunately the optimization where we remember the sum of all values invalid.