Perhaps you remember from elementary school that numbers with a digit sum divisible by three is also divisible by three (an so not a prime).  
So our number can't be 9 digits long (digit sum = `45`) nor 8 (digit sum = `36`). Our next best try is a 7-digit palindrome.

With the [QuickPerm algorithm](http://www.quickperm.org/) we generate all the permutations and test them for their primality.
This time we don't use a prime sieve, the numbers are just too big and it's faster with a simple naive prime test.

The rest is just implementation.
But the resulting code looks imho pretty nice because it really uses the four directions of befunge and often intersects with itself, even though I think that doesn't make it more readable.