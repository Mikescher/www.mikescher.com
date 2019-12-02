<Query Kind="Statements" />

var input_initial = File.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"12_input.txt"))[0].Substring(15).Select(p=>p=='#'?1:0).ToArray();
var input_rules = File
	.ReadAllLines(Path.Combine(Path.GetDirectoryName(Util.CurrentQueryPath), @"12_input.txt"))
	.Skip(1)
	.Where(p => !string.IsNullOrWhiteSpace(p))
	.Select( p => ( p.Split(' ')[0].Select(q=>q=='#'?1:0).ToArray() , p.Split(' ')[2][0]=='#'?1:0 ) )
	.Select( p => ( p.Item1.Reverse().Select((u,i)=>(u<<i)).Aggregate((s,t)=>s|t) , p.Item2 ) )
	.OrderBy(p => p.Item1)
	.Select(p => p.Item2)
	.ToArray();

int LEN = 2 * 20 + input_initial.Length + 2 * 20;
int OFF = LEN / 2 - input_initial.Length / 2;

int[] pots = new int[LEN];
int[] ipots = new int[LEN];

//input_initial.Dump();
//input_rules.Dump();

for (int i = 0; i < input_initial.Length; i++) pots[i+OFF]=input_initial[i];

int[] rules = new int[OFF*2+100];
for (int gen = 0; gen < 20; gen++)
{
	//string.Join("", rules.Select(p => p + "")).Dump();
	($"{gen:00}:  "+string.Join("", pots.Select(p => (p == 0) ? "." : "#"))).Dump();

	for (int p = 2; p < pots.Length-2; p++)
	{
		var rule = (pots[p - 2] << 4) | (pots[p - 1] << 3) | (pots[p - 0] << 2) | (pots[p + 1] << 1) | (pots[p + 2] << 0);
		
		rules[p]=rule;
		ipots[p]=input_rules[rule];
	}
	for (int p = 0, q = 0; p < pots.Length; pots[p++] = ipots[q++]) ;
}
($"{20:00}:  " + string.Join("", pots.Select(p => (p == 0) ? "." : "#"))).Dump();

"".Dump();

pots.Select((p,i) => (p,i-OFF)).Where(p => p.p>0).Sum(p=>p.Item2).Dump();