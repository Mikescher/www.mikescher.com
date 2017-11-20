Let's say LIMIT is our maximum value of k (`12 000`).

We start with an array of size LIMIT, filled with ones.
Our current sum is `LIMIT` and our current product is `1`.
To kickstart the whole progress we set `arr[1] = 2` (now sum is `LIMIT+1` and product is `2`).
We also remember the amount of changed fields, which are possible not one (initial `2`).

Now we iterate through all the possible array-combinations (with a few tricks to limit the search-space).

 - In each step we increment array[0]. And update the fields sum and product.
   This update is not that complex, sum is incrementing by `1` and
   product is `(product / arr[0]-1) * arr[0]`
 - While `prod > sum + (LIMIT - len)` we reset the current `arr[pos]` to `arr[pos + 1]` 
   and increment arr[pos + 1] 
   (and obviously increment `pos` and update `sum` and `product`)
 - After that we have a valid array valud. We can now test for which value of k this is a result
   (and if is is better than a previous found value)
 - The value of k is `k := LIMIT - (sum - prod)`
   The trick here is that we generate a solution by cutting away a lot of the ones at the end of our array 
   to get a solution where `prod = sum` (cutting ones decreemnts sum but leaves prod unchanged).
 - The condition to cut away only ones is given by our previous condition `prod > sum + (LIMIT - len)`.
 - After we have gone through all the possible values this way we only have calculate the sum of all the unique values
 
Because in the last step the list is almost sorted (not totally sorted but there arent that many cases where result[i] > result[i+1])
we can use a need little algorithm which eliminates duplicates by running through the list 
and doing sum occasional backtracing with an complexity of almost O(N).

I know, the algorithm got a bit complex, but it's pretty fast - even when converted to befunge.