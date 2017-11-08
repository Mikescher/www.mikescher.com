We start with a value of `1`.
Then we multiply one after another the numbers from `1` to `20` to our value (We call these `multiplicand` in the loop).

After each multiplications we search go through the numbers from `2` to `value` and search for a number `divisor` where

 - `value % divisor == 0`
 - `(value / divisor) % {0, multiplicand} == 0`

Then (after we found such a number) we can reduce the value with it (`value /= divisor`).

The reduction steps guarantees us that we find the **smallest** number and it prevents our *Int64* numbers from overflowing