The spider essentially travels on the hypotenuse of a triangle with the sides `A` and `B+C`.
For it to be the shortest path the condition `A <= B+C` must be true.

The amount of integer-cuboids for a given value M is "All integer-cuboids with `A=M`" plus integer-cuboids(M-1).
In our loop we start with `M=1` and increment it in every step.
We also remember the last value (for `M-1`) and loop until the value exceeds one million.

For a given value `A = M` we go through all possible `BC` value (`0 <= BC <= 2*A`) and test if `M^2 + BC^2` is an integer-square.
If such a number is found and `BC <= A` then this means we have found `BC/2` additional cuboids (there are `BC/2` different `B+C = BC` combinations where `B <= C`)
If, on the other hand `BC > A` then we have only found `A - (BC + 1)/2 + 1` additional cuboids (because the condition`A <= BC` must be satisfied).

One of the more interesting parts was the `isSquareNumber()` function, which test if a number `x` has an integer square-root.
To speed this function up *(it takes most of the runtime)* we can eliminate around 12% of the numbers with a few clever tricks.
For example if the last digit of `x` is `2`, x is never a perfect square-number. Or equally if the last hex-digit is `7`.
In our program we test twelve conditions like that:

~~~
x % 16  > 9
x % 64  > 57
x % 16 == 2
x % 16 == 3
x % 16 == 5
x % 16 == 6
x % 16 == 7
x % 16 == 8
x % 10 == 2
x % 10 == 3
x % 10 == 7
x % 3  == 2
~~~
**Sources:**
 - [ask-math.com](http://www.ask-math.com/properties-of-square-numbers.html)
 - [johndcook.com](http://www.johndcook.com/blog/2008/11/17/fast-way-to-test-whether-a-number-is-a-square/)
 - [stackoverflow.com](http://stackoverflow.com/questions/295579/fastest-way-to-determine-if-an-integers-square-root-is-an-integer)

If none of this pre-conditions is true we have to manually test the number.
We use the same the same [integer-squareroot](https://en.wikipedia.org/wiki/Integer_square_root) algorithm as in previous problems.
If `isqrt(x)^2 == x` the we can be sure that x is a perfect square number.