My first approach here was a simple brute force algorithm, but that one was *far* too slow. So I needed an more intelligent algorithm. And I have to say the one I came up is pretty quick and I like the concept that lies behind it.

First I calculated the primes from `0` to `1 000 000`.

Next I calculated the maximum chain *(starting by the first prime `2`)* with a sum less than one million.

Now think of all the primes laid down in an array side by side:

**1)** We move our chain from left to right until the sum exceeds one million (the movement is a really cheap operation: take the previous sum, subtract the most left prime and add the new prime from the reight side).

**2)** Then we shorten the chain length by one as we remove the most left prime.

**3)** After that we do the movement back wards (from right to left) until we end up at the left end of our prime array.

**4)** Then we again shorten the chain *(this time by removing the right tail)* and start over again (by moving right).

**X)** In every step we test if the current sum is a prime number and if so we print it and terminate the program.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
OOOOOOOOOOOOO  // the prime array
#####OOOOOOOO  // our chain
O#####OOOOOOO  // move right
OO#####OOOOOO
OOO#####OOOOO  // until sum > MAX_VALUE
OOOO####OOOOO  // shorten left
OOO####OOOOOO  // move left 
OO####OOOOOOO 
O####OOOOOOOO 
####OOOOOOOOO  // until left side is hit
###OOOOOOOOOO  // shorten right
O###OOOOOOOOO  // repeat until prime is found
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This algorithm works because we first test every possibility with maximum chain length, and then every with length = `maximum - 1` and so on and so on. So the first prime that we find is from the longest possible chain.

There are two nice things about this algorithm:

 - We don't need to calculate an extreme amount of prime sums. The step from the sum of one chain to the next is literally only an addition and an subtraction
 - Because we start with the longest chain and reduce its length in every step, the first prime we find is directly our optimal result.