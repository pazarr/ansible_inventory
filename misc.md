//Below is just a solution where we can manage arrays
// case "removeHostFromInventory":
//   if _, ok := postBody["hostname"] ; ok {
//     hostList := postBody["hostname"].([]interface{})
//     stringArray := make([]string, len(hostList))
//     for i, v := range hostList {
//       stringArray[i] = v.(string)
//     }
//     returnMsg = removeHostFromInventory(stringArray)
//   } else {
//     fmt.Println("Valid JSON query, but no action associated")
//     returnMsg["Timestamp"] = currentTime.String()
//     returnMsg["Level"] = "Info"
//     returnMsg["Message"] = "Valid JSON query, but no action associated"
//     returnMsg["Query"] = query
//   }
//   break
