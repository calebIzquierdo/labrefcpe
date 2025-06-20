pipeline {
    agent any

    environment {
        SONARQUBE_ENV = 'sonarqube' // Debe coincidir con el nombre del servidor en Jenkins
    }

    stages {
        stage('Clonar código') {
            steps {
                git branch: 'main', url: 'https://github.com/calebIzquierdo/labrefcpe.git'
            }
        }

        stage('Análisis SonarQube') {
            steps {
                withSonarQubeEnv("${SONARQUBE_ENV}") {
                    sh "${tool 'SonarScanner'}/bin/sonar-scanner"
                }
            }
        }
    }

    post {
        success {
            echo '✅ Análisis SonarQube completado con éxito.'
        }
        failure {
            echo '❌ Falló el análisis con SonarQube.'
        }
    }
}
