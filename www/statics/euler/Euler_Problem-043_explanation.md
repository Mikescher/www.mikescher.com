While trying to optimize this problem I found that you don't even need a program to solve this.
You can easily get the result by calculating it on paper.
I have documented my calculations in my [Github repo](https://github.com/Mikescher/Project-Euler_Befunge).
But I wanted an program to do this (where you could for example change the constraints), so I wrote this.

The code here was a tight fit into the Befunge-93 80x25 grid, not because of some big data structures but because of a lot of code.

Here we generate all combinations from the last digit to the first, we significantly limit the amount of possible combinations by checking the constraints for every number.  
For example we are at `???????410`, we then don't need to evaluate the first 7 digits because constraint 7 is violated (divisibility of d_789 by 17).
This way instead of evaluating `3,628,800` possibilities we only have to look at `1702`.

Pen-and-paper solution
======================


We can rule out a lot of combinations by simply looking at our rules. I divided my thought processes into steps:

**Step 1:**

 - d_1 != d_2 != d_3 != d_4 != d_5 != d_6 != d_7 != d_8 != d_9    *(palindromic)*
 - d_1 is not `0`
 - d_234 is divisible by 2  => d_4 is even
 - d_345 is divisible by 3  => `(d_3 + d_4 + d_5) % 3 = 0`
 - d_456 is divisible by 5  => d_6 is `0` or `5`
 - d_567 is divisible by 7
 - d_678 is divisible by 11
 - d_789 is divisible by 13
 - d_89A is divisible by 17

**Step 2:**

if d_6 is `0` then d_678 starts with a `0`, and because d_678 is divisible by 11: `d_7 == d_8`. This conflicts with our palindrome rule.

Therefore d_6 = `5`.

**Step 3:**

d_6 is `5` and d_678 is divisible by 11. There are only 8 possibilities for d_678:

~~~
506, 517, 528, 539, 561, 572, 583, 594
~~~

**Step 4:**

d_789 is divisible by 13, together with the possibilities for d_78 there are only 4 possibilities left for d_6789:

~~~
5286, 5390, 5728, 5832
~~~

**Step 5:**

d_89A is divisible by 17, then we can again - together with the previous result - look at the possibilities for d_6789A:

~~~
52867, 53901, 57289
~~~

**Step 6:**

d_567 is divisible by 7, d_6 is `5` and d_7 is `2`, `3` or `7`. There are now only 2 possible values for d_56789A left: 

~~~
357289, 952867
~~~

**Step 7:**

Both values contain `2`, `5`, `7`, `8`, `9`, so d_1 - d_4 can't be any of those

**Step 8:**

d_345 is divisible by 3. d_5 is `3 or 9` and d_4 is even and the possible digits are `0`, `1`, `2`, `3`, `4`, `6` and `9` (`9` only for d_5).  
The possible values for d_345 are therefore:

~~~
063, 069, 309, 603, 609
~~~

And so the possible values for d_3456789A:

~~~
06357289, 06952867, 30952867, 60357289, 60952867
~~~

number 2 and 5 are not palindromic, so the numbers left are:

~~~
06357289, 30952867, 60357289
~~~

**Step 9:**

The only numbers left are now `1` and `4` and there are no rules left to consider.  
We can now list the resulting numbers by using the 3 numbers from before and every combination of `1` and `4`:

 - 14 06357289
 - 41 06357289

----

 - 14 30952867
 - 41 30952867

----

 - 14 60357289
 - 41 60357289

**Step 10:**

The final step is now to calculate the sum of these numbers:

~~~
   1406357289
+  4106357289
+  1430952867
+  4130952867
+  1460357289
+  4160357289

= 16695334890
~~~