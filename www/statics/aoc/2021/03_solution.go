package advent

import (
	"AdventOfCode2021/util"
	"fmt"
	"strconv"
)

func Day03Part1(ctx *util.AOCContext) (string, error) {

	gamma := ""
	epsilon := ""
	for i := 0; i < 12; i++ {
		mc, lc := getMostAndLeastCommonBit(ctx.InputLines(), i)
		gamma += string(mc)
		epsilon += string(lc)
	}

	intGamma, err := strconv.ParseInt(gamma, 2, 64)
	if err != nil {
		return "", err
	}
	intEpsilon, err := strconv.ParseInt(epsilon, 2, 64)
	if err != nil {
		return "", err
	}

	return fmt.Sprintf("%d", intGamma*intEpsilon), nil
}

func Day03Part2(ctx *util.AOCContext) (string, error) {
	var err error

	resOxy := int64(-1)
	resCO2 := int64(-1)

	valOxy := ctx.InputLines()
	valCO2 := ctx.InputLines()
	for i := 0; i < len(ctx.InputLines()[0]); i++ {
		oxy, _ := getMostAndLeastCommonBit(valOxy, i)
		_, co2 := getMostAndLeastCommonBit(valCO2, i)

		ctx.Printf("MCB[Oxy]: %v\n\n", string(oxy))
		ctx.Printf("LCB[CO2]: %v\n\n", string(co2))

		newOxy := make([]string, 0)
		newCO2 := make([]string, 0)

		for _, v := range valOxy {
			if v[i] == oxy {
				newOxy = append(newOxy, v)
			}
		}
		valOxy = newOxy

		for _, v := range valCO2 {
			if v[i] == co2 {
				newCO2 = append(newCO2, v)
			}
		}
		valCO2 = newCO2

		if len(valOxy) == 1 {
			resOxy, err = strconv.ParseInt(valOxy[0], 2, 64)
			if err != nil {
				return "", err
			}
			ctx.Printf("Oxy := %v\n\n", resOxy)
		}

		if len(valCO2) == 1 {
			resCO2, err = strconv.ParseInt(valCO2[0], 2, 64)
			if err != nil {
				return "", err
			}
			ctx.Printf("CO2 := %v\n\n", resCO2)
		}

		ctx.Printf("CO2:\n%v\n\n", valCO2)
		ctx.Printf("Oxy:\n%v\n\n", valOxy)
	}

	ctx.Printf("Result := %v * %v = %v\n\n", resOxy, resCO2, resOxy*resCO2)
	return fmt.Sprintf("%d", resOxy*resCO2), nil
}

func getMostAndLeastCommonBit(lines []string, pos int) (uint8, uint8) {
	count0 := 0
	count1 := 0
	for _, line := range lines {
		if line[pos] == '0' {
			count0++
		} else {
			count1++
		}
	}
	if count1 >= count0 {
		return '1', '0'
	} else {
		return '0', '1'
	}
}
