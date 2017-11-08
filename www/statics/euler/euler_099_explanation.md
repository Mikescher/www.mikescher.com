For every number we normalize the Exponentiation to base 2.
(We search the equivalent Power `2^x`).
And then we only compare the exponents with each other, practically this
means we compare the length of the number in binary representation.

We chose 2 as our base because this way we don't have to worry too much about 
the precision of our calculations (befunge has no native floating point values).
If we would have found two entries with the same (overall highest) exponent, we would 
have to calculate the exponent to a higher precision, but fortunately this did not happen.

From `b^e` we can get the normalized fraction `2^(e * log2(b))`.
But because befunge has no log2 operator we have to go through the dirty work of manually approximating log2.

We use [this][1] algorithm to calculate log2.

First we calculate the integer part by simple searching the biggest number `2^n` where `2^n < b`

Then the real part equals `log2(2^(-n) * b)`, because we don't want to caclulate with real numbers we 
insert a Precision factor `F` (in this program we used a value of 1 million).

Now `y = 2^-n * b` and `rp = log2(y)`. We calculate y by dividing b n-times with two.

Our final result will be `r = n * e + rp * e`. We can already calculate `n*e`, the only missing part is `rp*e`, 
which we will call `exporp`.

Then we repeat the following steps until the value of exporp is no longer changing:

 - count the number of times `m` we have to square `y` until `y >= 2` 
 - `y = y^(2^m) / 2`
 - add `m` to `msum`, the collective sum of all calculated `m` values until now
 - divide `e` `msum`-times by two and add the result to `exporp`

Now we have calculated `exporp`, our result is `r = n * e + exporp`.

With this method we can calculate the exponent of our normalized exponentiation.
Next we simply iterate through the whole inpt and search the line number with the greatest base2-exponent.

[1]: https://en.wikipedia.org/wiki/Binary_logarithm#Iterative_approximation