namespace AdventOfCode2019_16_2
{
	const DAY     = 16;
	const PROBLEM = 2;

	export async function run()
	{
		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const message = input.trim().split("").map(p => parseInt(p));

		let offset = parseInt(message.slice(0,7).map(p=>p.toString()).reduce((a,b)=>a+b));

		let off_offset = Math.floor(offset / message.length) * message.length;

		let step = [];
		for(let i=off_offset/message.length; i<10_000; i++) for(const d of message) step.push(d);
		step = step.slice(offset - off_offset);

		for (let i=0; i < 100; i++) 
		{
			step = StupidBigFFT(step);

			AdventOfCode.outputConsole(`[${i}] ` + step.slice(0, 8).map(p=>p.toString()).reduce((a,b)=>a+b));
			await AdventOfCode.sleep(0);
		}

		AdventOfCode.output(DAY, PROBLEM, step.slice(0, 8).map(p=>p.toString()).reduce((a,b)=>a+b));
	}

	function StupidBigFFT(msg: number[])
	{
		let result = new Array(msg.length);

		let sum = 0;
		for (let i=msg.length-1; i >= 0; i--)
		{
			sum = (sum + msg[i]) % 10;

			result[i] = sum;
		}

		return result;
	}
}
