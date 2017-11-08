Only after at least sixty-two mathematical programs in befunge you will **truly** appreciate a hashtable.

For real, everything would be so much better if I could retrieve this stuff in `O(1)`.

My approach is pretty straight-forward. We calculate an permutation-insensitive hash.
Then store them together with the times it appeared in a hashmap *(I mean a list -.-)*.
Now we just go through all the cubes until a single hash appeared five times. In C# with a Dictionary this takes around 10ms.