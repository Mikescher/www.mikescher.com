The key to solve this problem is effectively iterating through the permutations for a given width and height (`perms[w, h]`).

First we look at the baseline with `width=1`. The basic case `perms[1,1]` is `1`.
After that `perms[1,h] = perms[1,h-1] + h` (so we can iterate easily through all these solutions).

With the baseline in place we can see that `perms[w, h] = perms[w, h-1] + perms[w, 1] * h`.

Then we just iterate through all the possibilities and search for the smallest difference.
We can stop increasing the width when `perms[w, 1] > 2,000,000` and similar stop increasing the height when `perms[w, h] > 2,000,000` or `w > h`.
The second conditions stems from the fact that `perms[w, h] == perms[h, w]` *(it's a mirrored functions)*.

Through these limiting conditions and the fact that each step is pretty fast (just a few additions and multiplications) this algorithm is *really* fast.
*(We only test around 10000 values before our search space is depleted)*