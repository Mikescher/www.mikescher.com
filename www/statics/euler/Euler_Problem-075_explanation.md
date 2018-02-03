Luckily there is a simple formula to generate [Pythagorean triples](https://en.wikipedia.org/wiki/Pythagorean_triple#Generating_a_triple).

~~~
a = k * (m*m - n*n);
b = k * (2*m*n);
c = k * (m*m + n*n);
~~~

We have a cache of the size `1500001` the we go through all the values for `m` and `n` where `2*m*m + 2*m*n <= LIMIT`.

When we have found a triple we look in the cache at position `a+b+c`:
 - If the value is not set (0) we write the the triple-hash (`(a*7 + b)*5 + c`) at the position and increment the result.
 - If there is already an hash that equals with our current triple we do nothing
 - If there is already an different hash we write `-1` in the cache and decrement the result.
 - If there is an `-1` in the cache we do nothing

So at the end we have the amount of sum's with exactly one solution in our result-value.

We have to test for equal hashes because its possible to find the same tuple multiple times (with different `k` values).