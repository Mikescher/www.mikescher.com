The algorithm here enumerates through every possible combination using an approach similar to counting binary:

- Increment the last digit until our total sum is greater 200 (test for every combination if total sum == 200)
- Then set every field from back to front to zero until you find a non-zero field
- Set this field also to zero
- Increment the field before ... repeat
- Abort the loop when you have used every field

That is probably not the most efficient way, but I optimized this brute-force variant enough that it becomes viable.