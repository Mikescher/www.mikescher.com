This one needs a little bit of a bigger explanation:

First let me say that I'm aware that this is neither the fastest algorithm nor the best algorithm to represent in funge-space. But its reasonable fast and I liked the challenge of doing such a big program (in terms of raw code size) in befunge.

First we take a 4-dimensional cache of all possible number combinations (so an `bool[10][10][10][10]` array) where we remember if a combination is valid.
In our program we represent it as an 2D-field with `X=s1*10+s2` and `Y=s4*10+s3`.

Initially we set all fields to true where `0<s1<s2<s3<s4<10`

Now we first test all combinations if they can produce `1` and remove the ones from our cache that can't.
Then we do `2`, then `3` and so on until only one combination is left. This combination will be our solution.

The interesting part (with an quite bad algorithm) is determining if a combination can produce a specific target number. (*For better understanding it could be good to look at the C# version of this problem in this git repo*)

In the first step we combine all possible two numbers together (with all 4 possible operators) so we get the same problem with three numbers and a target value. There are in total 48 unique ways of trimming the combination down to three numbers:

~~~
[s1+s2, s3, s4]
[s1-s2, s3, s4]
[s1*s2, s3, s4]
[s1/s2, s3, s4] if s2 != 0
[s1+s3, s2, s4]
[s1-s3, s2, s4]
[s1*s3, s2, s4]
[s1/s3, s2, s4] if s3 != 0
[s1+s4, s2, s3]
[s1-s4, s2, s3]
[s1*s4, s2, s3]
[s1/s4, s2, s3] if s4 != 0
...
~~~

This is more or less a [divide and conquer](https://en.wikipedia.org/wiki/Divide_and_conquer_algorithms) algorithm (but the divide part is kinda missing :D )

Next we do the same for now three numbers and a target value (now there are only 24 ways of combining the numbers) to get only two values

Then (as you could have guessed) we do the same for two value (8 combinations, but only 6 unique ones)

And in the last step we only have to test if the number equals the target.

In our top-most method (let's call it **test_0()** ) there are then two possibilities: 
Either all 48 code paths failed and we can scratch that combination from our cache, or one succeeded and we keep it.

This algorithm makes (heavy) use of the callstack. One method is calling another one many times with different parameter and this one is calling the next (up until four layers deep).
In befunge we have nothing like a callstack so we need to do all the management of parameters, state and return position by hand.
But one thing works in our favor: At each time every method is at most one type on the callstack (no recursion or similar stuff here).
Because of that we can write the parameter and program-counter to fixed position on the funge grid for each method.
It will never be the case that two calls override each others state.

Up until here everything sounds nice and friendly. The problem stems from the division operation.
Befunge only understands integer numbers, but in this program it is possible that a intermediate value is a fraction (but the end result still is an integer).
I was not *that* far away from implementing fractions into this program, but fortunately (the runtime is thanking me :D ) there is another way.
We pre-multiply all numbers by a fixed value (this is called [fixed-point arithmetic](https://en.wikipedia.org/wiki/Fixed-point_arithmetic)).
The challenge was to find the correct factor.
It should be an integer that is divisible by all numbers from one to ten, so no single division can introduce errors.
And the smallest number is `2520`, this magic number will be the factor for our fixed-point arithmetic.

When doing fixed-point arithmetic addition and subtraction are straight-forward:

~~~
C = A+B   =>   n*C = n*A + n*B
~~~

A little more attention is needed when doint multiplication and division, for the first we have to divide by the factor after the operation and for the second we have to multiply it:

~~~
C = A*B   =>   n*C = (n*A * n*B) / n
C = A/B   =>   n*C = ((n*A)*n / (n*B)
~~~

It is important that we multiply the dividend by the factor and not the result of the division, otherwise the decimal places will get lost.

As usual a final note from me: Nice problem. 10/10 would solve again