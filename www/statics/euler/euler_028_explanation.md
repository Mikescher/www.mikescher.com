Let's look ate the diagonal numbers of our 5x5 grid:

|n |info           |
|--|---------------|
|25|starting number|
|21| = 25 - **4**  |
|17| = 21 - **4**  |
|13| = 17 - **4**  |
|9 | = 13 - **4**  |
|7 | = 9  - **2**  |
|5 | = 7  - **2**  |
|3 | = 5  - **2**  |
|1 | = 3  - **2**  |

You can probably see the pattern here. The rest of the algorithm is simply loop from 1001^2 to 1, subtracting the right amount each round and in the end summing up all numbers.

I have this little code to calculate the sum of stack values until a zero is encountered:

```befunge
>+\:#<_$
```

Perhaps it's useful for someone else.