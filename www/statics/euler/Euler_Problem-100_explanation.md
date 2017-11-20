Let's say `b` is the number of blue disks, `r` the number of red disks 
and `n` is the total number.
From the problem description we can infer this:
~~~
b+r = n                    (1)
0 < b < n                  (2)
0 < r < n                  (3)
n > 10^12                  (4)
(b/n)*((b-1)/(n-1)) = 1/2  (5)
~~~

Now we can user (1) and (2) to get a formula for `b` and `n`:

~~~
(b/n)*((b-1)/(n-1)) = 1/2
2*b*(b-1) = n * (n-1)
2*b^2 - 2*b = n^2 - n
2 * (b^2 - b) = n^2-n
0.5 * (2b)^2 - (2b) = (n)^2 - (n)
2*(b^2) - 2b = (n)^2 - (n)

b = 1/2 ( sqrt(2n^2 - 2n + 1) + 1 )
~~~

For the last formula we search for integer solutions.
We can now either solve this manually with diophantine equations,
or we ask [Wolfram|Alpha](www.wolframalpha.com/input/?i=2*b*b-2b+%3D+n*n-n).
Which gives us the following two formulas:

~~~
s = sqrt(2)

b = (1/8) * (  2*(3-2*s)^m  +  s*(3-2*s)^m  +  2*(3+2*s)^m  -  s*(3+2*s)^m  +  4)
n = (1/4) * (   -(3-2*s)^m  -  s*(3-2*s)^m  -    (3+2*s)^m  +  s*(3+2*s)^m  +  2)

m element Z, m >= 0
~~~

We can see both formulas contain the expression sqrt(2), which is not 
only fractional but also irrational. Which is a problem with the strict integer
operations in befunge.

But we can sidestep this by using a special number notation `r * 1 + s * sqrt(2)`.
In every step we calculate the "real" part of the number plus a multiple of `sqrt(2)`.
This is kinda like the common notation of [imaginary numbers](https://en.wikipedia.org/wiki/Imaginary_number).

Now all we have to do is create algorithms for addition and multiplication in our new number format.

~~~
(r1 + s1 * sqrt(2)) + (r2 + s2 * sqrt(2)) = (r1+r2) + (s1+s2) * sqrt(2)
(r1 + s1 * sqrt(2)) * (r2 + s2 * sqrt(2)) = (r1*r2+2*s1*s2) + (s1*r2+r1*s2) * sqrt(2)
~~~

Now we can use the formulas from Wolfram|Alpha until we find a value for `n > 10^12`.

In the end this problem wasn't that hard to code when all the preparations were done.
Also it's pretty fast.