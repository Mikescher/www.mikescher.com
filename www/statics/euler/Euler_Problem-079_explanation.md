This is one of the problems i really enjoyed solving.

We make the assumption that our final pass code has no duplicate digits (If we hadn't found a solution we would need to change that part).
This is a pretty good assumption because no attempt has a duplicate digit in it.

> *Side note:* This leaves us with a 8-digit code, because only 8 digits are used (`4` and `5` are missing).

First we generate a 10x10 grid where we remember the absolute ordering of the numbers from our attempts (eg `3` is before `8` or `9` is after `2`).
If we inspect this data we can see that every field (for numbers in our pass code) is set, the fifty login attempts generate more than enough data for this.

> *Side note:* In fact there are only 33 **unique** login attempts

Then we can simply sort an array of the valid digits with this ordering. And - frankly - I find this is a really neat way of doing this.

Because we sort only eight numbers, sorting-performance is not a big factor.
So I searched for the simplest (easiest to implement) sorting algorithm I could find.
This was surprisingly not Bubble-sort, but [Gnome Sort](https://en.wikipedia.org/wiki/Gnome_sort) (accordingly to the author "the simplest sort algorithm").
Which was pretty easy to implement in Befunge (and for 8 values is the runtime of O(n^2) not *that* bad).

A last thing: For a problem where I used an two-dimensional cache **and** that has input data I was surprised to fit everything in the Befunge-93 80x25 size restrictions.
