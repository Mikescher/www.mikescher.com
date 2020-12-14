use crate::common::AdventOfCodeDay;

#[derive(Debug)]
enum CType {
    North,
    East,
    South,
    West,
    TurnRight,
    TurnLeft,
    Forward,
}

#[derive(Debug)]
pub struct Day12 {
    input: Vec<(CType, i32)>,
}

impl Day12 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/12_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let data = input_str
                        .lines()
                        .map(Day12::parse_cmd)
                        .collect::<Vec<(CType, i32)>>();

        Self {
            input: data
        }
    }

    fn parse_cmd(line: &str) -> (CType, i32) {
        (match &line[0..1] {
            "N" => CType::North,
            "E" => CType::East,
            "S" => CType::South,
            "W" => CType::West,
            "L" => CType::TurnLeft,
            "R" => CType::TurnRight,
            "F" => CType::Forward,
            _   => panic!(),
        }, line[1..].parse::<i32>().unwrap())
    }
}

impl AdventOfCodeDay for Day12 {

    fn task_1(&self) -> String {
        if is_verbose!() {
            for e in &self.input { verboseln!("{:?}", e); }
            verboseln!();
            verboseln!();
        }

        let deltas: [(i32,i32); 4] = [(1,0),(0,1),(-1,0),(0,-1)];

        let mut x: i32 = 0;
        let mut y: i32 = 0;
        let mut d: i32 = 0;

        for cmd in &self.input {
            
            match cmd.0 {
                CType::North     => { y -= cmd.1; },
                CType::East      => { x += cmd.1; },
                CType::South     => { y += cmd.1; },
                CType::West      => { x -= cmd.1; },
                CType::TurnLeft  => { d = (d + 16 - (cmd.1 / 90)) % 4 },
                CType::TurnRight => { d = (d + 16 + (cmd.1 / 90)) % 4 },
                CType::Forward   => { x += deltas[d as usize].0 * cmd.1; y += deltas[d as usize].1 * cmd.1; },
            }

            verboseln!("[{},{}|{}] {:?}", x, y, d, cmd);
        }

        return (x.abs() + y.abs()).to_string();
    }

    fn task_2(&self) -> String  {
        
        let mut ship_x: i32 = 0;
        let mut ship_y: i32 = 0;
        let mut wp_x: i32 = 10;
        let mut wp_y: i32 = 1;

        verboseln!("Ship:[{},{}] WP:[{},{}]", ship_x, ship_y, wp_x, wp_y);
        for cmd in &self.input {
            
            match cmd.0 {
                CType::North     => { wp_y += cmd.1; },
                CType::East      => { wp_x += cmd.1; },
                CType::South     => { wp_y -= cmd.1; },
                CType::West      => { wp_x -= cmd.1; },
                
                CType::TurnLeft  => { for _ in 0..(cmd.1/90) { (wp_x, wp_y) = (-wp_y,  wp_x); } },
                CType::TurnRight => { for _ in 0..(cmd.1/90) { (wp_x, wp_y) = ( wp_y, -wp_x); } },

                CType::Forward   => { ship_x = ship_x + wp_x*cmd.1; ship_y = ship_y + wp_y*cmd.1; },
            }

            verboseln!("Ship:[{},{}] WP:[{},{}] {:?}", ship_x, ship_y, wp_x, wp_y, cmd);
        }

        return (ship_x.abs() + ship_y.abs()).to_string();
    }
}