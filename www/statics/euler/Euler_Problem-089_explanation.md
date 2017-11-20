I don't know why this problem has such a high number.

We simply parse all the roman numbers in the file and create minimal roman literals from them.
Then we simply sum all the length-differences together.

And it wasn't really hard to write algorithms for these two conversions. Both are pretty straight forward.
(And for number->roman we didn't even have to go the whole way, we only need the *length* of the result)

For the conversion roman->number we first search for the length of the roman literal.
Then we go backwards through the letters and get the value of each letter (cached by the array in line one).
If the value of the letter is greater than the last value we increment the total value (by the letter value),
otherwise we decrement it.
I found it easier to traverse the number backwards because we can cache the value of the last digit and do the algorithm this way with less `g` calls.

For the conversion number->optimal_roman_length i found this nice formula:

~~~
(n/1000) + R[(N%1000)/100] + R[(N%100)/10] + R[N%10]

// n is our number
// R is defined as an array with { 0, 1, 2, 3, 2, 1, 2, 3, 4, 2 }
~~~