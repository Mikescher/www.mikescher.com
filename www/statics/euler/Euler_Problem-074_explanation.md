The factorial part is pretty easy - we cache the factorials from 1 to 9 and then we can calculate `facdigitsum(n)` in `O(log_10(n))`.

The problemdescription tells us there are only seven numbers in a loop (`{169, 363601, 1454}`, `{871, 45361}`, `{872, 45362}`).
So every other chain ends with a number mapping to itself. We manually insert these seven numbers in our grid and calculate the rest (where we only need to test if `f(n) == f(n-1)`).

And we cache ever calculated value of `chainlength()` in our 1000000-element array. So as soon as we reach an already calculated number we can stop.
This works because there are no loops (except the seven pre-inserted values) and every chain is strictly linear.

Be sure to check out the pre-optimized version of this to see just how much more condensed this version is :)