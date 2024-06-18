import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:praktikum_06/firebase_options.dart';
import 'package:praktikum_06/ui/splash.dart';
import 'package:praktikum_06/utils/routes.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  );
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: "Praktikum 6",
      debugShowCheckedModeBanner: false,
      navigatorKey: NAV_KEY,
      onGenerateRoute: generateRoute,
      home: const SplashScreen(),
    );
  }
}
