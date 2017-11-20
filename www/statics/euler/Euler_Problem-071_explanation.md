For every denominator from `1` to `1 000 000` we generate a possible fraction where the numerator is `(d * 3) / 7`.
(Every other fraction is either greater than `3/7` or has a greater difference than the generated).

Now everything thats left is finding the fraction with the smallest difference to `3/7`.

The difference of two fractions is calculated (without floating points) by:

~~~
n1/d1 - n2/d2  ==  (n1*d2 - n2*d1)/(d1*d2)
~~~

The rest is just iterating through all the possible fractions and in each step remembering the current best.

We don't even need to reduce the result to get a *proper* fraction. 
If it could be reduced we would have got the reduced version first.
(Because it has an smaller denominator).