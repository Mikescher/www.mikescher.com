Yep, I *hate* this problem.  
Not only is there an enormous amount of input data that makes our program huge in size.
But it contains a lot of different cases, rules and logic that needs be represented in our program

But none the less I tried to come up with an compact algorithm for scoring a set of cards

~~~
Get(@"https://projecteuler.net/project/resources/p054_poker.txt")
	.Where(p => GetScore(p.deck_1) > GetScore(p.deck_2))
	.Count()
	.Dump();
~~~

~~~
int GetScore(Card[] cards) {
	List<long> SUMS = new List<long>{ H*H*H*H*H, C*C*C*C*C, S*S*S*S*S, D*D*D*D*D };

	int[] array = new int[15];
	int score = 0;
	int flushSum = 1;
	int highCard = 0;
	int highGroup = 0;
	int straightIndex = 0;

	foreach(Card c in cards) {
		highCard = Math.Max(highCard, c.value);
		flushSum *= c.suit;
		if (array[c.value] > 0)
			highGroup = Math.Max(highGroup, c.value);
		array[c.value]++;
	}

	for(int i = 1; i < 15; i++)
	{
		score += (array[i]-1)*(array[i])*256;
		
		if (array[i] > 0 && array[i-1] > 0)
			straightIndex++;
	}
	score += highCard;
	score += highGroup * 15;

	if (straightIndex == 4)
		score += 2540;
	if (SUMS.Contains(flushSum))
		score += 2550;
		
	return score;
}
~~~

The different values are carefully crafted in such a way, that you can compare the score of two hands and get the winner

 Card                | Calculation    | Score
---------------------|----------------|---------------------------------------------
High Card            | {0-14} * [1]   | = {0-14}
High Card (in Group) | {0-14} * [15]  | = {0-210}
One Pair             | 2 * [256]      | = 512  *(+ HighCard)* *(+ HighGroup)*
Two Pairs            | 4 * [256]      | = 1024 *(+ HighCard)* *(+ HighGroup)*
Three of a Kind      | 6 * [256]      | = 1536 *(+ HighCard)* *(+ HighGroup)*
Straight             | [2540]         | = 2540 *(+ HighCard)* *(+ HighGroup)*
Flush                | [2550]         | = 2550 *(+ HighCard)* *(+ HighGroup)*
Full House           | 10 * [256]     | = 2560 *(+ HighCard)* *(+ HighGroup)*
Four of a Kind       | 12 * [256]     | = 3072 *(+ HighCard)* *(+ HighGroup)*
Straight Flush       | [2540] + [2550]| = 5090 *(+ HighCard)* *(+ HighGroup)*
Royal Flush          | [2540] + [2550]| = 5090 *(+ HighCard)* *(+ HighGroup)*

One last side note: A **royal flush** is not really a independent rank. Because of the "highest card in the rank" rule a royal flush is always better than a straight flush (because the highest card is an ace)
