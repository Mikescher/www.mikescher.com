Well, this is practically extremely simple path finding.

We generate an array where we remember the shortest distance from [0,0] to this node.
Initially we can set `distance[0, 0] = data[0,0]`

The we got through our data row by row and column by column.
The distance of every node we visit is the minimum of `top-node-distance + own value` and `left-node-distance + own value`.

Then after we iterated through every single node the result is written in the bottom right corner.