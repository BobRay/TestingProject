echo "Running MODX2 tests"
call codecept run acceptance T18_ResourceProtectionMODX3Cest --env firefox,modx2 --env chrome,modx2

echo "Running MODX3 tests"
call codecept run acceptance T18_ResourceProtectionMODX3Cest --env firefox,modx3 --env chrome,modx3