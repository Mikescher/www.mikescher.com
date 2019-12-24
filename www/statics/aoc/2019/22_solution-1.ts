namespace AdventOfCode2019_22_1
{
	const DAY     = 22;
	const PROBLEM = 1;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const cmds = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => parseLine(p))

		AdventOfCode.setIntermedOutputSize("0.275vw");

		let data = [...Array(10007).keys()];

		for (const cmd of cmds)
		{
			if (cmd.type === CmdType.CUT && cmd.param >= 0)
			{
				data = [...data.slice(cmd.param), ...data.slice(0, cmd.param)];
			}
			else if (cmd.type === CmdType.CUT && cmd.param < 0)
			{
				data = [...data.slice(data.length + cmd.param), ...data.slice(0, data.length + cmd.param)];
			}
			else if (cmd.type === CmdType.DEAL)
			{
				let d2 = Array(data.length);
				for(let i=0; i<data.length;i++) d2[(i*cmd.param) % data.length] = data[i];
				data = (cmd.param === 1) ? d2.reverse() : d2;
			}
			else throw cmd;

			let str = "";
			let len = 50;
			for (let i=0; i<(data.length / len)+1; i++)
			{
				str += data.slice(i*len, (i+1)*len).map(p => p.toString().padStart(5, ' ')).join(" ") + "\n";
			}
			await AdventOfCode.outputIntermed(str);

			AdventOfCode.outputConsole(data.map(p => p.toString()).join(" "));
		}


        AdventOfCode.output(DAY, PROBLEM, data.indexOf(2019).toString());
	}

	function parseLine(str: string): Cmd
	{
		const m0 = str.match(new RegExp('^cut (-?[0-9]+)$'));
		if (m0 != null) return new Cmd(CmdType.CUT, parseInt(m0![1]));

		const m1 = str.match(new RegExp('^deal into new stack$'));
		if (m1 != null) return new Cmd(CmdType.DEAL, 1);

		const m2 = str.match(new RegExp('^deal with increment ([0-9]+)$'));
		if (m2 != null) return new Cmd(CmdType.DEAL, parseInt(m2![1]));

		throw str;
	}

	enum CmdType { CUT, DEAL }

	class Cmd
	{
		type: CmdType;
		param: number;

		constructor(t:CmdType, n: number) { this.type=t; this.param=n; }
	}
}
