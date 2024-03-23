import 'package:flutter/material.dart';

void main() {
  runApp(const MainApp());
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'Praktikum 04',
        home: Scaffold(
          appBar: AppBar(
            leading: const Icon(Icons.arrow_back),
            backgroundColor: Colors.green[700],
          ),
        ));
  }
}
