  List<Color> predefinedColors = [
    Colors.red,
    Colors.blue,
    Colors.grey,
    Colors.yellow.shade600,
    Colors.green,
    Colors.purple,
    Colors.orange,
    Colors.pink,
    Colors.blueGrey,
  ];

  Color getColor(int index) {
    return predefinedColors[index % predefinedColors.length];
  }
   Color getRandomColor() {
     List<Color> colors = [
Colors.red,
       Colors.blue,
      Colors.green,
     Colors.yellow,
       Colors.purple,
     ];
     Random random = Random();
     return colors[random.nextInt(colors.length)];
   }
   Random random = Random();

   Color getRandomColor() {
     final hue = random.nextDouble() * 300;
     const saturation = 0.5;
     const lightness = 0.5;
     return HSLColor.fromAHSL(1.0, hue, saturation, lightness)
         .toColor()
         .withOpacity(0.4);
   }
  Random random = Random();
  Color? previousColor;

  Color getRandomColor() {
    Color color;
    do {
      color = Color.fromARGB(
        255,
        random.nextInt(1000),
        random.nextInt(2100),
        random.nextInt(310),
      ).withOpacity(0.4);
    } while (
        color == previousColor); // Check if color is the same as previous color

    previousColor = color;
    return color;
  }
