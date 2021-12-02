package advent

import (
	"AdventOfCode2021/util"
	"errors"
	"strconv"
	"strings"
)

func Day2Part1(ctx *util.AOCContext) (string, error) {
	pos := 0
	depth := 0

	for _, line := range ctx.InputLines() {
		split := strings.Split(line, " ")
		cmd := split[0]
		val, err := strconv.ParseInt(split[1], 10, 32)
		if err != nil {
			return "", err
		}
		switch cmd {
		case "forward":
			pos += int(val)
		case "up":
			depth -= int(val)
		case "down":
			depth += int(val)
		default:
			return "", errors.New(cmd)
		}
	}

	return strconv.Itoa(pos * depth), nil
}

func Day2Part2(ctx *util.AOCContext) (string, error) {
	pos := 0
	depth := 0
	aim := 0

	for _, line := range ctx.InputLines() {
		split := strings.Split(line, " ")
		cmd := split[0]
		val, err := strconv.ParseInt(split[1], 10, 32)
		if err != nil {
			return "", err
		}
		switch cmd {
		case "forward":
			pos += int(val)
			depth += int(val) * aim
		case "up":
			aim -= int(val)
		case "down":
			aim += int(val)
		default:
			return "", errors.New(cmd)
		}
	}

	return strconv.Itoa(pos * depth), nil
}
