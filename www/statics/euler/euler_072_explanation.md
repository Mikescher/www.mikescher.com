First we need the number of proper reduced fractions for a denominator `d`.
This is the amount of numbers `d<n` with `gcd(d,n) == 1`.
Coincidentally this is again Eulers Phi-Function.

Now we need to find the sum over all phi values from `1` to `1 000 000`.

First we get all the prime numbers from `2` to `limit/2` (with an [Sieve of Eratosthenes](https://en.wikipedia.org/wiki/Sieve_of_Eratosthenes)).
Then we iterate through all possible prime combinations smaller than the limit (practically this is prime factorization).
While we do this we calculate on the side the phi value of these numbers (with the prime factorization this is trivial) and sum these values together.

For all values bigger than `LIMIT/2` where we haven't got a factorization we use `phi(p) = p-1`.
Because these *must* be prime. *(see [Eulers totient function](https://en.wikipedia.org/wiki/Euler's_totient_function))*

The rest is a bit of clever optimization, so this all does not take too long.

 - First we assume every number is prime and calculate the sum of the phi function of all these primes.
   Then when we find a number (that is not a prime) we subtract the old (wrong) value from the result and add the new (correct) value.
 - We abort our loops early when we run into a number `x > limit`. Because every other factor will only increase `x`.
 - The value of phi is always calculated from the last phi value. So we don't need to totally recalculate it in every step.

After looking a little bit around this is not ***the** fastest solution to this problem.
But it's the one I found and I think it's reasonable fast.