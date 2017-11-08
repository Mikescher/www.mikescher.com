As the problem description states this is similar to problem-081.

Again we generate an node-array where we remark the minimal distance from the left side to this node.
Initially we can initialize the left column with its input values.
(`distance[0, y] = data[0, y]`) and all the other nodes with an absurdly high number.

Then we iterate through all remaining columns:  

For each column `x` we go all possible ways from the previous column. That means:
 - Choose the start-row `y` (and do this for all possible start rows)
 - Get the distance to reach this row by calculating `distance[x-1, y] + data[x, y]`
 - Then go all the way up and down and calculate the distance on the way `distance[x-1, y] + data[x, y] + data[x, y - 1] + data[x, y - 2] ...`
 - For each node where this distance is lesser than the current one we update distance array.
 - *Optimization node:* Once we find a node where the distance is greater than a previous calculated we can stop further traversing the column (in this direction)
 
At the end we have an distance array where each node is the minimal distance to reach this node from the left side.
Our result is then the minimal value of the most-right column.

*Note:* While problem-081 hat an time complexity of O(n) this one has one of O(n^2).
But for an 80x80 array that's still fast enough and really not an problem.