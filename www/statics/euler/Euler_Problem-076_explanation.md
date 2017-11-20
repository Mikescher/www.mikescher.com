The big trick is - similar to many other problems - *caching*.

This problem remembered me a little bit of problem-15.
We use a `100x100` grid to remember pre-calculated sums.

So in cell [3, 6] is the amount of sums which result in `6`, start with `3` and have all summands in descending order:

~~~
3 + 3
3 + 2 + 1
3 + 1 + 1
~~~

You see `cache[3,6] = 3`.

Now to find a new value (for example `[4, 7]`) we just have to look at the our cache:

~~~
7 = 4 + x
sum(x) = 7-4 = 3

// first_digit_of_x <= first_digit, because of the descending order
sum(x) = sum([n, 3]); n = [1..3]
sum(x) = [3, 3] + [2, 3] + [1, 3] 
~~~

You see it's important not only to remember the amount but also the first (= highest) summand, 
so we can guarantee the oder of the sums (an this way that we don't count any sums multiple times).

*Note:* `cache[a, a]` is always `1`. But the problem rules dictate that when we calculate the final result we must ignore this (`100 = 100` is not a valid solution)

Oh and this algorithm improves the native approach (enumerating all solutions) from `O(wtf)` to `O(n^2)`.
I'm not sure if I would be still alive when my first algorithm finishes :)

----

**Edit:** 

I did a little optimization:

The value of cell `[d, s]` is now the sum of all previous cells from `[0, s]` to `[d, s]`.

This way we don't have to iterate through all the cells from 0 to d every time.
We can just look at the biggest cell which contains the sum of all previous.